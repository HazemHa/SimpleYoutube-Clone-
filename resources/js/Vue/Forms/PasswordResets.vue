<template>
<form>
<v-text-field
      v-model="email"
      :error-messages="requriedMessage"
      label="email"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="token"
      :error-messages="requriedMessage"
      label="token"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="created_at"
      :error-messages="requriedMessage"
      label="created_at"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-btn @click="submit">submit</v-btn>
<v-btn @click="clear">clear</v-btn>
</form>
</template>
<script>
  import { validationMixin } from 'vuelidate'
  import { required} from 'vuelidate/lib/validators'
  export default {
    mixins: [validationMixin],
    validations: {
      requiredField: { required}
    },
    data: () => ({
 email: '',
 token: '',
 created_at: ''
}),
    computed: {
      requriedMessage () {
        const errors = []
        if (!this.$v.requiredField.$dirty) return errors
        !this.$v.requiredField.required && errors.push('this field is required.')
        return errors
      }
    },
    methods: {
      submit () {
        this.$v.$touch()
      },
      clear () {
        this.$v.$reset()
this.email = '';
this.token = '';
this.created_at = '';

      }
    }
  }
</script>
