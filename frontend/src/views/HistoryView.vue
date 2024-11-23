<script setup lang="ts">
import axios from 'axios'

import {ref} from 'vue'

const leads = ref([]);

axios.get('http://localhost/api/leads')
  .then(function (response) {
    leads.value = response.data
    // handle success
    console.log(response.data);
  })
  .catch(function (error) {
    // handle error
    console.log(error);
  })
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
          Action
        </th>
      </tr>
      </thead>
      <tbody>
      <tr
        v-for="lead in leads"
        :key="lead.id"
      >
        <td>{{ lead.name }}</td>
        <td>{{ lead.createdAt }}</td>
        <td>{{ lead.hasContact }}</td>
      </tr>
      </tbody>
    </v-table>
  </div>
</template>
