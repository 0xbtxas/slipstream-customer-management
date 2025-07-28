<template>
    <div>
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-md font-bold">Contacts</h3>
            <UButton @click="handleModalOpen(null)" color="secondary">
                Create
            </UButton>
        </div>
        <UTable :columns="columns" :data="contacts" />
        <ContactModal
            v-if="showModal"
            :contact="selected"
            :customerId="customerId"
            @close="handleModalClose"
        />
    </div>
</template>

<script setup lang="jsx">
import { ref } from "vue";
import ContactModal from "./ContactModal.vue";

const props = defineProps({
    contacts: Array,
    customerId: Number,
});
const emit = defineEmits(["update:contacts"]);

const showModal = ref(false);
const selected = ref(null);

const UButton = resolveComponent("UButton");
const popoverOpen = ref(0);

const columns = [
    {
        accessorKey: "first_name",
        header: "First Name",
    },
    {
        accessorKey: "last_name",
        header: "Last Name",
    },
    {
        header: "Actions",
        cell: ({ row }) => {
            return (
                <div class="space-x-1">
                    <UButton
                        icon="i-lucide-edit"
                        variant="outline"
                        size="xs"
                        onClick={() => handleModalOpen(row.original)}
                    />
                    <UPopover
                        open={popoverOpen.value === row.original.id}
                        v-slots={{
                            default: () => (
                                <UButton
                                    icon="i-lucide-trash"
                                    size="xs"
                                    variant="outline"
                                    color="error"
                                    onClick={() => {
                                        popoverOpen.value = row.original.id;
                                    }}
                                />
                            ),
                            content: () => (
                                <div class="p-2 text-sm">
                                    <p>Are you sure?</p>
                                    <div class="mt-2 flex gap-2 justify-end">
                                        <UButton
                                            color="gray"
                                            variant="ghost"
                                            size="xs"
                                            onClick={() => {
                                                popoverOpen.value = 0;
                                            }}
                                        >
                                            Cancel
                                        </UButton>
                                        <UButton
                                            color="red"
                                            size="xs"
                                            onClick={() => {
                                                deleteContact(row.original);
                                                popoverOpen.value = 0;
                                            }}
                                        >
                                            Confirm
                                        </UButton>
                                    </div>
                                </div>
                            ),
                        }}
                    />
                </div>
            );
        },
    },
];

const handleModalOpen = (contact) => {
    selected.value = contact ? { ...contact } : null;
    showModal.value = true;
};

const handleModalClose = async (updated) => {
    showModal.value = false;
    if (!updated) return;

    if (updated.id) {
        const { data } = await axios.put(
            `/api/customers/${props.customerId}/contacts/${updated.id}`,
            updated
        );
        const index = props.contacts.findIndex((c) => c.id === updated.id);
        if (index !== -1) props.contacts[index] = data.data;
    } else {
        const { data } = await axios.post(
            `/api/customers/${props.customerId}/contacts`,
            updated
        );
        props.contacts.push(data.data);
    }
    emit("update:contacts", props.contacts);
};

const deleteContact = async (contact) => {
    await axios.delete(
        `/api/customers/${props.customerId}/contacts/${contact.id}`
    );
    emit(
        "update:contacts",
        props.contacts.filter((c) => c.id !== contact.id)
    );
};
</script>
