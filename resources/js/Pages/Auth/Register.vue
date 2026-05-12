<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    no_kp: '',
    nama: '',
    emel: '',
    kata_laluan: '',
    kata_laluan_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('kata_laluan', 'kata_laluan_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="no_kp" value="No. Kad Pengenalan" />

                <TextInput
                    id="no_kp"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.no_kp"
                    required
                    autofocus
                    maxlength="12"
                    placeholder="123456789012"
                />

                <InputError class="mt-2" :message="form.errors.no_kp" />
            </div>

            <div class="mt-4">
                <InputLabel for="nama" value="Nama Penuh" />

                <TextInput
                    id="nama"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.nama"
                    required
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.nama" />
            </div>

            <div class="mt-4">
                <InputLabel for="emel" value="E-mel" />

                <TextInput
                    id="emel"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.emel"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.emel" />
            </div>

            <div class="mt-4">
                <InputLabel for="kata_laluan" value="Kata Laluan" />

                <TextInput
                    id="kata_laluan"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.kata_laluan"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.kata_laluan" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="kata_laluan_confirmation"
                    value="Sahkan Kata Laluan"
                />

                <TextInput
                    id="kata_laluan_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.kata_laluan_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.kata_laluan_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
