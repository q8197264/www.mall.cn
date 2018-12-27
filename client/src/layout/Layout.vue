<template>
    <div class="app-wrapper" :class="classObj">
        <sidebar class="sidebar-container"></sidebar>
        <div class="main-container">
            <navbar></navbar>
            <app-main></app-main>
        </div>
    </div>
</template>

<script>
import {Navbar, Sidebar, Appmain} from '@/layout/components'

export default {
    name: 'layout',
    components: {
        Navbar,
        Sidebar,
        Appmain
    }
}
</script>