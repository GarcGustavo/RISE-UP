<template>
  <div id="app">

    <markdown-editor toolbar="bold italic heading | image link | numlist bullist code quote | preview fullscreen"></markdown-editor>
    <markdown-editor v-model="data" :options="options"></markdown-editor>
    <markdown-editor name="html"></markdown-editor>
    <button type="button" @click="clickHandler">Reset</button>

    <div>{{ data }}</div>
  </div>
</template>

<script>
//import Editor from '@tinymce/tinymce-vue';
import Editor from 'v-markdown-editor'
import 'v-markdown-editor/dist/index.css';
//Vue.use(Editor);
export default {
  name: 'app',
  components: {
    //Editor
  },
  data(){
      return {
          data : 'Hello'
      };
  },
  mounted(){
     
  },
  methods: {
      clickHandler(){
          this.data = 'You reseted tinymce\'s content';
      }
  }
  
}
</script>
<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>