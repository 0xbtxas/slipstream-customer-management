<template>
    <div
        class="fixed inset-0 bg-black/50 flex justify-center items-center z-10"
    >
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">
                {{ contact?.id ? "Edit" : "Create" }} Contact
            </h2>

            <form @submit.prevent="submit">
                <UInput
                    v-model="form.first_name"
                    placeholder="First Name"
                    required
                    color="secondary"
                    class="w-full mb-2"
                />
                <UInput
                    v-model="form.last_name"
                    placeholder="Last Name"
                    required
                    color="secondary"
                    class="w-full mb-2"
                />

                <div class="text-right space-x-2">
                    <UButton
                        type="button"
                        @click="$emit('close')"
                        size="lg"
                        class="bg-gray-300"
                    >
                        Back
                    </UButton>
                    <UButton type="submit" size="lg" color="secondary">
                        Save
                    </UButton>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";

const props = defineProps({ contact: Object, customerId: Number });
const emit = defineEmits(["close"]);

const form = reactive({
    id: props.contact?.id,
    first_name: props.contact?.first_name ?? "",
    last_name: props.contact?.last_name ?? "",
});

const submit = () => {
    emit("close", { ...form });
};
</script>
