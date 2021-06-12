<template>
  <div>
    <h2 style="margin-bottom: 10px"> Send Message </h2>
    <form style="padding-right: 120px;" v-on:submit.prevent="sendMessage">
      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label">From</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded has-icons-left">
              <input class="input" type="text" id="from_name" v-model="from_name" placeholder="From Name">
              <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
            </p>
          </div>
          <div class="field">
            <p class="control is-expanded has-icons-left has-icons-right">
              <input class="input" type="email" required placeholder="From Email" id="from_email" v-model="from_email">
              <span class="icon is-small is-left">
          <i class="fas fa-envelope"></i>
        </span>
              <span class="icon is-small is-right">
          <i class="fas fa-check"></i>
        </span>
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label">To</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded has-icons-left">
              <input class="input" type="text" id="to_name" v-model="to_name" placeholder="To Name">
              <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
            </p>
          </div>
          <div class="field">
            <p class="control is-expanded has-icons-left has-icons-right">
              <input class="input" type="email" required placeholder="To Email" id="to_email" v-model="to_email">
              <span class="icon is-small is-left">
          <i class="fas fa-envelope"></i>
        </span>
              <span class="icon is-small is-right">
          <i class="fas fa-check"></i>
        </span>
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label">Subject</label>
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control">
              <input class="input" required type="text" id="subject" v-model="subject"
                     placeholder="e.g. Partnership opportunity">
            </div>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label">Body</label>
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control">
              <textarea class="textarea" required v-model="body" id="body"
                        placeholder="Explain how we can help you ..."></textarea>
            </div>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label">
          <!-- Left empty for spacing -->
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control">
              <button class="button is-primary">
                Send message
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'SendMail',
  data() {
    return {
      from_name: null,
      from_email: '',
      to_name: null,
      to_email: '',
      subject: '',
      body: '',
    }
  },
  methods: {
    sendMessage: function () {
      axios.post('http://localhost:7336/api/v1/mails', {
        from_name: this.from_name,
        from_email: this.from_email,
        to: [
          {
            name: this.to_name,
            email: this.to_email,
          }
        ],
        subject: this.subject,
        body: this.body,
      }).then(() => {
        alert('Done!');
        this.from_name = ''
        this.from_email = ''
        this.to_name = ''
        this.to_email = ''
        this.subject = ''
        this.body = ''
      }).catch((error) => {
        alert('Failed !' + error.response)
      })
    }
  }
}
</script>
