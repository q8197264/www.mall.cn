<template>
    <div id="layout">
        <el-container>
            <el-header>
                <el-menu
                        :default-active="activeIndex2"
                        class="el-menu-demo"
                        mode="horizontal"
                        @select="handleSelect"
                        background-color="#545c64"
                        text-color="#fff"
                        active-text-color="#ffd04b">
                    <el-menu-item index="1" v-for="m in menus">{{m.text}}处理中心</el-menu-item>
                    <el-submenu index="2">
                        <template slot="title">我的工作台</template>
                        <el-menu-item index="2-1">选项1</el-menu-item>
                        <el-menu-item index="2-2">选项2</el-menu-item>
                        <el-menu-item index="2-3">选项3</el-menu-item>
                        <el-submenu index="2-4">
                            <template slot="title">选项4</template>
                            <el-menu-item index="2-4-1">选项1</el-menu-item>
                            <el-menu-item index="2-4-2">选项2</el-menu-item>
                            <el-menu-item index="2-4-3">选项3</el-menu-item>
                        </el-submenu>
                    </el-submenu>
                    <el-menu-item index="3" disabled>消息中心</el-menu-item>
                    <el-menu-item index="4">订单管理</el-menu-item>
                </el-menu>
            </el-header>


            <el-container>
                <el-aside width="200px">Aside</el-aside>
                <el-main>Main</el-main>
            </el-container>
        </el-container>
    </div>
</template>

<script>
//    import header from './nav_bar.vue'
//    import sidebar from './side_bar.vue'
    export default {
        name: 'layout',
        data(){
            return {
                activeIndex: '1',
                activeIndex2: '1',
                list:[
                    {id:0, text:'a'},
                    {id:1, text:'b'},
                    {id:2, text:'c'},
                    {id:3, text:'d'}
                ]
            }
        },
        created:function(){
            this.getCatetory();
        },
        computed:{
            menus:function(){
                return this.list.filter(function (v) {
                    return v.status===0;
                });
            }
        },
        methods: {
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            },
            getCatetory: function () {
                this.$http.get('/categories').then(function(res){
                    console.log(res.body);
                }, function(r){
                    console.log('请求失败处理');
                });
            }
        }
    }

</script>