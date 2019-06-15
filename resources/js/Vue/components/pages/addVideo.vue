<template>
  <form>
    <v-text-field
      v-model="title"
      :error-messages="requriedMessage"
      label="title"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"
    ></v-text-field>
    <v-text-field
      v-model="description"
      :error-messages="requriedMessage"
      label="description"
      required
      @input="$v.requiredField.$touch()"
      @blur="$v.requiredField.$touch()"
    ></v-text-field>
  your video :


    <v-text-field  label="Select Video" @click='launchFilePicker' v-model='videoName' prepend-icon='attach_file'></v-text-field>

    <input
      type="file"
      ref="file"
      :name="videoName"
      @change="onFileChange(
          $event.target.name, $event.target.files)"
      style="display:none"
    >
    <br>
    <br>



    <v-btn @click="submit">submit</v-btn>
    <v-btn @click="clear">clear</v-btn>
  </form>
</template>
<script>
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
export default {
  mixins: [validationMixin],
  validations: {
    requiredField: { required }
  },
  data: () => ({
    title: "",
    description: "",
    channel_id: "",
    videoName: "",
    video: null
  }),
  computed: {
    requriedMessage() {
      const errors = [];
      if (!this.$v.requiredField.$dirty) return errors;
      !this.$v.requiredField.required && errors.push("this field is required.");
      return errors;
    }
  },
  methods: {
       launchFilePicker() {
      this.$refs.file.click();
    },
    submit() {
      let data = new FormData();
      data.append("title", this.title);
      data.append("description", this.description);
      data.append("video", this.video);
      this.$store
        .dispatch("videos/addVideo", data)
        .then(res => {
            if(res.data.success){
                this.$toaster.success("uploaded Done :D");
            }
          console.log(res);
        })
        .catch(err => {
         this.$toaster.error(err);
        });
      this.$v.$touch();
    },
    clear() {
      this.$v.$reset();
      this.title = "";
      this.description = "";
    },
    onFileChange(fieldName, file) {
     this.video = file[0];
     this.videoName = this.video.name;

    }
  }
};
</script>
