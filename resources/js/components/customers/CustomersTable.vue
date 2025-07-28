<template>
    <div>
        <UTable :data="customers" :columns="columns" />
        <div class="mt-4 flex justify-center">
            <UPagination
                v-model:page="currentPage"
                :items-per-page="props.itemsPerPage"
                :total="props.total"
                color="secondary"
                active-color="secondary"
            />
        </div>
    </div>
</template>

<script setup lang="jsx">
import { ref } from "vue";

const props = defineProps([
    "customers",
    "itemsPerPage",
    "currentPage",
    "total",
]);
const emit = defineEmits(["edit", "delete"]);
const currentPage = defineModel("currentPage");

const popoverOpen = ref(null);

const columns = [
    {
        accessorKey: "name",
        header: "Name",
        meta: {
            class: {
                th: "text-center",
                td: "text-center",
            },
        },
    },
    {
        accessorKey: "reference",
        header: "Reference",
        meta: {
            class: {
                th: "text-center",
                td: "text-center",
            },
        },
    },
    {
        accessorKey: "category",
        header: "Category",
        meta: {
            class: {
                th: "text-center",
                td: "text-center",
            },
        },
        cell: ({ row }) => row.getValue("category").name,
    },
    {
        accessorKey: "contacts_count",
        header: "No. of Contacts",
        meta: {
            class: {
                th: "text-center",
                td: "text-center",
            },
        },
    },
    {
        header: "Actions",
        meta: {
            class: {
                th: "text-center",
            },
        },
        cell: ({ row }) => {
            return (
                <div class="flex gap-1 justify-center">
                    <UButton
                        icon="i-lucide-edit"
                        size="xs"
                        variant="outline"
                        onClick={() => emit("edit", row.original.id)}
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
                                                popoverOpen.value = null;
                                            }}
                                        >
                                            Cancel
                                        </UButton>
                                        <UButton
                                            color="red"
                                            size="xs"
                                            onClick={() => {
                                                deleteCustomer(row.original);
                                                popoverOpen.value = null;
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

const deleteCustomer = async (customer) => {
    await axios.delete(`/api/customers/${customer.id}`);
    emit("delete");
};
</script>
