<template>
<form>
<v-text-field
      v-model="name"
      :error-messages="requriedMessage"
      label="name"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="avatar"
      :error-messages="requriedMessage"
      label="avatar"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="email"
      :error-messages="requriedMessage"
      label="email"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="password"
      :error-messages="requriedMessage"
      label="password"
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
 name: '',
 avatar: '',
 email: '',
 password: ''
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
this.name = '';
this.avatar = '';
this.email = '';
this.password = '';

      }
    }
  }
</script>
