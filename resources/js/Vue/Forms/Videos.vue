<template>
<form>
<v-text-field
      v-model="title"
      :error-messages="requriedMessage"
      label="title"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="description"
      :error-messages="requriedMessage"
      label="description"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="published"
      :error-messages="requriedMessage"
      label="published"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="url"
      :error-messages="requriedMessage"
      label="url"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="thumbnail"
      :error-messages="requriedMessage"
      label="thumbnail"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="allow_comments"
      :error-messages="requriedMessage"
      label="allow_comments"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="views"
      :error-messages="requriedMessage"
      label="views"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"></v-text-field>
<v-text-field
      v-model="channel_id"
      :error-messages="requriedMessage"
      label="channel_id"
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
 title: '',
 description: '',
 published: '',
 url: '',
 thumbnail: '',
 allow_comments: '',
 views: '',
 channel_id: '',
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
this.title = '';
this.description = '';
this.published = '';
this.url = '';
this.thumbnail = '';
this.allow_comments = '';
this.views = '';
this.channel_id = '';
this.user_id = '';

      }
    }
  }
</script>
