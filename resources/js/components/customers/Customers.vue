<template>
    <UApp>
        <div>
            <div class="flex justify-between mb-4">
                <h1 class="text-2xl font-bold">Customers</h1>
                <UButton
                    @click="handleModalOpen"
                    size="lg"
                    color="secondary"
                    label="Create"
                />
            </div>
            <div class="flex gap-2 items-center mb-2">
                <UInput
                    v-model="searchFilter"
                    size="lg"
                    color="secondary"
                    placeholder="Search..."
                />
                <USelect
                    v-model="categoryFilter"
                    :items="categories"
                    size="lg"
                    color="secondary"
                    class="w-48"
                />
            </div>
            <CustomersTable
                @edit="handleCustomerEdit"
                @delete="fetchCustomers"
                :customers="filteredCustomers"
                :itemsPerPage="itemsPerPage"
                v-model:currentPage="currentPage"
                :total="total"
            />
            <CustomerModal
                v-if="showModal"
                @close="handleModalClose"
                @save="handleModalClose"
                :customerId="selectedCustomerId"
                :categories="categories"
            />
        </div>
    </UApp>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import CustomersTable from "./CustomersTable.vue";
import CustomerModal from "./CustomerModal.vue";

const categories = ref([]);
const showModal = ref(false);
const searchFilter = ref("");
const categoryFilter = ref(null);
const total = ref(0);
const currentPage = ref(1);
const filteredCustomers = ref([]);
const selectedCustomerId = ref(null);

const itemsPerPage = 10;

const fetchCategories = async () => {
    const { data: categoryData } = await axios.get("/api/categories");
    const newCategories = [
        {
            label: "Select Category",
            value: null,
        },
        ...categoryData.data.map((category) => ({
            label: category.name,
            value: category.id,
        })),
    ];
    categories.value = newCategories;
};

const handleModalOpen = () => {
    selectedCustomerId.value = null;
    showModal.value = true;
};

const handleModalClose = () => {
    showModal.value = false;
    fetchCustomers();
};

const handleCustomerEdit = (custId) => {
    selectedCustomerId.value = custId;
    showModal.value = true;
};

let debounceTimeout;

const fetchCustomers = async () => {
    const params = { page: currentPage.value, per_page: itemsPerPage };
    if (searchFilter.value) params.search = searchFilter.value;
    if (categoryFilter.value) params.category_id = categoryFilter.value;
    const queryString = new URLSearchParams(params).toString();

    const { data } = await axios.get(`/api/customers?${queryString}`);
    filteredCustomers.value = data.data;
    currentPage.value = data.meta.current_page;
    total.value = data.meta.total;
};

watch([searchFilter, categoryFilter, currentPage], () => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        fetchCustomers();
    }, 300);
});

const fetchInitialData = async () => {
    fetchCategories();
    fetchCustomers();
};

onMounted(fetchInitialData);
</script>
