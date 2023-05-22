<script setup>
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
    close: Boolean,
    message: String,
    deleteButton: String,
});
const emit = defineEmits(["update:close", "deleteAction"]);
</script>

<template>
    <Modal :show="close" @close="emit('update:close', false)">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 text-center">
                {{ $t(message) }}
            </h2>

            <div class="mt-6 flex justify-center">
                <SecondaryButton @click="emit('update:close', false)">
                    {{ $t("cancel") }}
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    @click="emit('deleteAction')"
                >
                    {{ $t(deleteButton) }}
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
