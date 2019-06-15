<template>
<form>
<v-text-field
      v-model="body"
      :error-messages="requriedMessage"
      label="body"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="approved"
      :error-messages="requriedMessage"
      label="approved"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="video_id"
      :error-messages="requriedMessage"
      label="video_id"
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
 body: '',
 approved: '',
 video_id: '',
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
this.body = '';
this.approved = '';
this.video_id = '';
this.user_id = '';

      }
    }
  }
</script>
