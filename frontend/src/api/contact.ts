import axios from 'axios'

interface Contact {
  name: String,
  phone: String,
  comment: String,
}

export default {
  async createContact(leadId: number, contact: Contact) {
    const {data} = await axios.post(`https://rodent-guided-primarily.ngrok-free.app/api/contact/${leadId}`, contact)

    return data
  }
}
