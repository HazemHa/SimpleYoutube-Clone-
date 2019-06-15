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
      v-model="logo"
      :error-messages="requriedMessage"
      label="logo"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="cover"
      :error-messages="requriedMessage"
      label="cover"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="about"
      :error-messages="requriedMessage"
      label="about"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="user_id"
      :error-messages="requriedMessage"
      label="user_id"
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
 logo: '',
 cover: '',
 about: '',
 user_id: ''
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
this.logo = '';
this.cover = '';
this.about = '';
this.user_id = '';

      }
    }
  }
</script>
