<template>
  <ol class="dd-list">
    <li v-for="list in lists" :key="list.id" class='dd-item' :data-order="list.order" :data-id="list.id">
      <div class='dd-handle'>
        <span class="item=icon" v-html="list.icon"> {{ list.icon }}</span>
        <span class="item-title"> {{ list.title }}</span>
        <span class="item-url"> {{ list.url }}</span></div>
      <div class='action-area'>
        <a href="#"
           class="btn btn-info edit-info"
           data-toggle="modal"
           data-target="#editMenuItemModal"
           @click="editMenuItem(list.id)"
           :data-id="list.id"><i class="material-icons">edit</i></a>
        <a
            href='#'
            class='btn btn-danger cs-danger'
            @click="deleteMenuItem(list.id)"
            :data-id="list.id"><i class="material-icons">delete</i></a>
      </div>
      <draggable-menu
          v-if="(list.childrens.length > 0)"
          :prefix="prefix"
          :lists="list.childrens"
          :settings="settings"
          :defaultSettings="defaultSettings"
          :editMenuItem="editMenuItem"
          :deleteMenuItem="deleteMenuItem">
      </draggable-menu>
    </li>
  </ol>
</template>

<script>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import toastr from 'toastr';

export default {
  props: {
    prefix: String,
    lists: Array,
    settings: Object,
    defaultSettings: Object,
    isDestroyAble: Boolean,
    editMenuItem: Function,
    deleteMenuItem: Function,
  },
  name: 'draggable-menu',
  setup(props) {
    const isNestMenu = ref(false);
    const depth = ref((props.settings.depth) ? props.settings.depth : props.defaultSettings.depth);

    onMounted(() => {
      if (props.lists && props.lists.length > 0) {
        isNestMenu.value = true;
      }

      toastr.options.closeButton = true;
      initNestable('#nestmenu');
    });

    function initNestable(selector = '#nestable', options = {}) {
      const self = this;
      setTimeout(function () {
        if (isNestMenu.value) {
          if (props.isDestroyAble) {
            $(selector).nestable('destroy');
          }

          $(selector).nestable({
            group: 1,
            maxDepth: parseInt(depth.value),
            callback: function (l, e) {
              const list = l.length ? l : $(l.target);
              const menus = list.nestable('toArray');

              axios({
                url: props.prefix + '/menu/item/sort',
                method: 'POST',
                responseType: 'json',
                data: {
                  'menus': menus
                },
              })
                  .then(res => {
                    if (res.data.success == true) {
                      toastr.success('Sorted Successfully.', 'Menu Item');
                    }
                  });
            }
          });
        }
      }, 1000);
    }

    function destroyNestable(selector) {
      setTimeout(function () {
        $(selector).nestable('destroy');
      }, 500);
    }

    return {
      isNestMenu,
      depth,
      initNestable,
      destroyNestable
    }
  }
}
</script>
<style>
</style>