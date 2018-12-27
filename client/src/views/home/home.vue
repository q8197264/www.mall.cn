<template>
  <el-container class="root_container">
    <el-aside width="200px">
      <v-menu>{{name}}</v-menu>
    </el-aside>

    <el-container>
      <el-header><v-head></v-head></el-header>
      <el-main>
        <keep-alive><router-view></router-view></keep-alive>
      </el-main>
    </el-container>
  </el-container>
</template>

<script>
// import ajaxHelper from '@/api/ajax-helper.js'
import Header from '@/layout/header'

export default {
  components: {
    'v-head': Header
  },
  data () {
    return {
      name:'sdfsdf'
    }
  }
}

</script>