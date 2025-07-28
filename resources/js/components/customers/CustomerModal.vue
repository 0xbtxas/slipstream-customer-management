<template>
    <div
        class="fixed inset-0 bg-black/50 flex justify-center items-center z-10"
    >
        <div class="bg-white rounded-lg w-full max-w-2xl p-6">
            <form @submit.prevent="saveCustomer">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Customers - Detail</h2>
                    <div class="space-x-2">
                        <UButton
                            type="button"
                            @click="$emit('close')"
                            size="xl"
                            class="bg-gray-300"
                        >
                            Back
                        </UButton>
                        <UButton type="submit" size="xl" color="secondary">
                            Save
                        </UButton>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <UInput
                            v-model="customerData.name"
                            placeholder="Name"
                            size="lg"
                            color="secondary"
                            required
                        />
                        <UInput
                            v-model="customerData.reference"
                            placeholder="Reference"
                            size="lg"
                            color="secondary"
                            required
                        />
                        <USelect
                            :items="categories"
                            v-model="customerData.customer_category_id"
                            size="lg"
                            color="secondary"
                            class="w-48"
                        />
                    </div>
                    <div class="space-y-2">
                        <UInput
                            type="date"
                            v-model="customerData.start_date"
                            size="lg"
                            color="secondary"
                            required
                        />
                        <UTextarea
                            v-model="customerData.description"
                            placeholder="Description"
                            size="lg"
                            color="secondary"
                            required
                        ></UTextarea>
                    </div>
                </div>
            </form>

            <ContactsTable
                v-model:contacts="customerData.contacts"
                :customerId="customerData.id"
                class="my-4"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import ContactsTable from "./contacts/ContactsTable.vue";

const props = defineProps({ customerId: Number, categories: Array });
const emit = defineEmits(["close", "save"]);

const categories = props.categories.slice(1);
const customerData = ref({
    contacts: [],
    customer_category_id: categories[0].value,
});

const fetchCustomer = async () => {
    if (!props.customerId) return;
    try {
        const { data } = await axios.get(`/api/customers/${props.customerId}`);
        customerData.value = data.data;
        customerData.value.customer_category_id = data.data.category.id;
    } catch (error) {
        alert("Failed to get categories");
    }
};

const saveCustomer = async () => {
    try {
        if (customerData.value.id) {
            await axios.put(
                `/api/customers/${customerData.value.id}`,
                customerData.value
            );
        } else {
            await axios.post("/api/customers", customerData.value);
        }
        emit("save");
    } catch (error) {
        alert("Failed to save customer");
    }
};

onMounted(fetchCustomer);
</script>
