<template>
  <div class="modal fade" tabindex="-1" role="dialog" :id="idmodal">
    <div class="modal-dialog" :class="modalSize" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <slot name="title"></slot>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <slot name="body"></slot>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <slot name="button"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    idmodal: {default:'form-modal'},
    modalSize: {default: ''}
  }
}
</script>