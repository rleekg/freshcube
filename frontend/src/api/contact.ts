import axios from 'axios'

interface Contact {
  name: String,
  phone: String,
  comment: String,
}

export default {
  async createContact(leadId: number, contact: Contact) {
    const {data} = await axios.post(`http://localhost/api/contact/${leadId}`, contact)

    return data
  }
}
