<template>
  <div class="home">
    <div id="nav">
      <router-link to="/loading">go loading</router-link>
      <router-link to="/">go home</router-link> |
      <router-link to="/login">go login</router-link> |
      <!--<router-link to="/login">go login page</router-link>-->
    </div>
    <h1>hello asdsad</h1>
    <img src="../assets/logo.png">
  </div>
</template>

<script>
export default {
  name: 'home',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
