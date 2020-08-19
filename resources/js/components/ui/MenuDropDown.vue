<template>
  <li class="nav-item dropdown">
    <menu-sidebar :class="'has-dropdown'">{{ menuChild.menu.menu_name }}</menu-sidebar>
    <ul class="dropdown-menu" v-for="(menu, index) in menuChild.menu.menu_item" :key="index">
      <li v-for="mn in menu" :key="mn.id">
        <menu-sidebar>{{ mn.name }}</menu-sidebar>
      </li>
    </ul>
  </li>
</template>
<script>
export default {
  props: ['child'],
  computed:{
    menuChild: function() {
      return JSON.parse(this.child);
    }
  },
  mounted: function(){
    console.log(this.menuChild);
  }
}
</script>