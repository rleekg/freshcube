<script setup lang="ts">
import {defineEmits, ref} from 'vue'
import {required} from '@vuelidate/validators'
import {useVuelidate} from '@vuelidate/core'
import api from '@/api/contact'

interface StepParamFormProps {
  leadId: number,
}

const props = defineProps<StepParamFormProps>()
const dialog = ref(false)

const contact = ref({
  name: null,
  phone: null,
  comment: null,
});

const rules = {
  name: {required},
  phone: {required},
  comment: {required},
}

const v$ = useVuelidate(rules, contact)

const create = async () => {
  v$.value.$validate();

  if (v$.value.$invalid) {
    return
  }

  await api.createContact(props.leadId, contact.value)
    .then(response => {
      dialog.value = false;
      emits('submit');
    })
    .catch(error => {
      console.log(error)
    })
};

interface StepFormEmits {
  (e: 'close'): void

  (e: 'submit'): void
}

const emits = defineEmits<StepFormEmits>()
</script>

<template>
  <v-dialog
    v-model="dialog"
    width="80%"
    height="80%"
    scrollable
  >
    <template v-slot:activator="{ props }">
      <v-btn
        dark
        v-bind="props"
      >
        Привязка контакта
      </v-btn>
    </template>
    <v-card>
      <v-toolbar
        title="Привязка контакта"
        dense
      >
        <v-btn title="Закрыть" @click="dialog = false" icon>
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12" sm="12">
              <v-text-field
                v-model="contact.name"
                :error-messages="v$.name.$errors.map(e => e.$message)"
                @input="v$.name.$touch"
                @blur="v$.name.$touch"
                variant="outlined"
                label="ФИО"
                type="string"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="12">
              <v-text-field
                v-model="contact.phone"
                :error-messages="v$.phone.$errors.map(e => e.$message)"
                @input="v$.phone.$touch"
                @blur="v$.phone.$touch"
                variant="outlined"
                label="Телефон"
                type="string"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="12">
              <v-textarea
                v-model="contact.comment"
                :error-messages="v$.comment.$errors.map(e => e.$message)"
                @input="v$.comment.$touch"
                @blur="v$.comment.$touch"
                variant="outlined"
                label="Комментарий"
                type="string"
                required
              ></v-textarea>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          variant="text"
          @click="dialog = false"
        >
          Отменить
        </v-btn>
        <v-btn
          color="blue-darken-1"
          variant="text"
          @click="create"
        >
          Сохранить
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
