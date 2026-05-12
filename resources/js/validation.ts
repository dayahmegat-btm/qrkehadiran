import { defineRule, configure } from 'vee-validate';
import { required, email, min, max, confirmed, numeric } from '@vee-validate/rules';
import { localize } from '@vee-validate/i18n';

// Define validation rules
defineRule('required', required);
defineRule('email', email);
defineRule('min', min);
defineRule('max', max);
defineRule('confirmed', confirmed);
defineRule('numeric', numeric);

// Configure validation messages
configure({
    generateMessage: localize({
        en: {
            messages: {
                required: 'This field is required',
                email: 'Please enter a valid email',
                min: 'This field must be at least {length} characters',
                max: 'This field must not exceed {length} characters',
                confirmed: 'Passwords do not match',
                numeric: 'This field must be a number',
            },
        },
        ms: {
            messages: {
                required: 'Medan ini diperlukan',
                email: 'Sila masukkan e-mel yang sah',
                min: 'Medan ini mestilah sekurang-kurangnya {length} aksara',
                max: 'Medan ini tidak boleh melebihi {length} aksara',
                confirmed: 'Kata laluan tidak sepadan',
                numeric: 'Medan ini mestilah nombor',
            },
        },
    }),
    validateOnBlur: true,
    validateOnChange: true,
    validateOnInput: false,
    validateOnModelUpdate: true,
});
