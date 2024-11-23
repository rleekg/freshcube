<?php declare(strict_types=1);

namespace App\Leads\Service;

use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\Factories\CustomFieldValuesModelFactory;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\LinkModel;
use AmoCRM\Models\NoteType\CommonNote;

final class LeadService
{
    public function __construct(
        private AmoCRMClient $amoCRMClient
    ) {
    }

    public function getLeads(): array
    {
        $leadApi = $this->amoCRMClient->api->leads();

        $filter = new LeadsFilter();
        $filter->setLimit(10);
        $filter->setOrder('createdAt', 'desc');

        /** @var        LeadModel[] $leads */
        $leads = $leadApi->get($filter, ['contacts']);

        $data = [];

        foreach ($leads as $lead) {
            $data[] = [
                'id' => $lead->getId(),
                'name' => $lead->getName(),
                'createdAt' => $lead->getCreatedAt(),
                'hasContact' => null !== $lead->getContacts() && !$lead->getContacts()->isEmpty()
            ];

        }

        return $data;
    }

    public function createContact(int $leadId, array $contactData)
    {
        $contact = new ContactModel();
        $contact->setName($contactData['name']);

        $customFields = $this->amoCRMClient->api->customFields(EntityTypesInterface::CONTACTS);
        $contactCustomFieldsValues = new CustomFieldsValuesCollection();
        $phoneField = $customFields->getOne('630989');
        $fieldValue = CustomFieldValuesModelFactory::createModel([
            'field_id' => $phoneField->getId(),
            'field_type' => $phoneField->getType(),
            'values' => [['value' => $contactData['phone']]],
            'field_code' => $phoneField->getCode(),
            'field_name' => $phoneField->getName(),
        ]);
        $contactCustomFieldsValues->add($fieldValue);
        $contact->setCustomFieldsValues($contactCustomFieldsValues);

        $contactsApi = $this->amoCRMClient->api->contacts();
        $contact = $contactsApi->addOne($contact);

        $lead = new LeadModel();
        $lead->setId($leadId);

        $link = new LinkModel();
        $link->setToEntityId($contact->getId());
        $link->setToEntityType(EntityTypesInterface::CONTACTS);

        $leadApi = $this->amoCRMClient->api->leads();
        $leadApi->link($lead, $link);

        $notesApi = $this->amoCRMClient->api->notes(EntityTypesInterface::CONTACTS);
        $note = new CommonNote();
        $note->setText($contactData['comment']);
        $note->setEntityId($contact->getId());
        $notesApi->addOne($note);
    }
}
