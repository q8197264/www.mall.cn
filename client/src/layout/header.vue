<template>
    <el-container class="head_container">
        <el-row class="elRow" style="width:100%;text-align:right;margin:0 60px;">
            <div class="clear">
                <el-col :span="24" class="clear head_right">
                    <!--通知喇叭-->
                    <!--@click="showMyselfs('isShowAbout')"-->
                    <div class="info_icon" >
                        <el-badge is-dot class="item is-dot">
                            <i class="el-icon-bell"></i>
                        </el-badge>
                    </div>

                    <div class="head_userInfo">
                        <div class="userIcon">
                            <img :src="img" alt="user">
                            <span>123123213</span>
                        </div>
                    </div>

                </el-col>
            </div>

        </el-row>
    </el-container>
</template>

<script>
    export default {}
</script>