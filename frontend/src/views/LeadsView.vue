<script setup lang="ts">
import axios from 'axios'

import {ref} from 'vue'
import CreateContact from "@/components/CreateContact.vue";

const leads = ref([]);

const loadData = async () => {
  await  axios.get('http://localhost/api/leads')
    .then(function (response) {
      leads.value = response.data
      // handle success
      console.log(response.data);
    })
    .catch(function (error) {
      // handle error
      console.log(error);
    })
}
loadData();

</script>

<template>
  <div>
    <v-table>
      <thead>
      <tr>
        <th class="text-left">
          ID
        </th>
        <th class="text-left">
          Название
        </th>
        <th class="text-left">
          Дата создания
        </th>
        <th class="text-left">
          Есть контакт
        </th>
        <th class="text-left">
          Действия
        </th>
      </tr>
      </thead>
      <tbody>
      <tr
        v-for="lead in leads"
        :key="lead.id"
      >
        <td>{{ lead.id }}</td>
        <td>{{ lead.name }}</td>
        <td>{{ lead.createdAt }}</td>
        <td>
          {{ lead.hasContact ? 'Да' : 'Нет' }}
        </td>
        <td>
          <CreateContact
            @submit="loadData"
            :lead-id="lead.id"
          />
        </td>
      </tr>
      </tbody>
    </v-table>
  </div>
</template>
