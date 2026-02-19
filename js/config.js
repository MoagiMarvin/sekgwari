// Supabase Configuration
const SUPABASE_URL = 'https://fjxdgtxxzgciorgrzbuk.supabase.co';
const SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZqeGRndHh4emdjaW9yZ3J6YnVrIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzExMzAxNzUsImV4cCI6MjA4NjcwNjE3NX0.I0_XxRck3aWYyl3NTj5yFVMIgVXspL9mTgySBvTeHlw';

// Initialize the Supabase client
// We use a distinct name to avoid overwriting the library reference
if (typeof window.supabaseClient === 'undefined') {
    window.supabaseClient = window.supabase.createClient(SUPABASE_URL, SUPABASE_KEY);
}
// Define a global variable that all scripts can use
var supabase = window.supabaseClient;

// Shared function to update school contact info across all pages
async function loadSchoolSettings() {
    const { data: settings, error } = await supabase
        .from('site_settings')
        .select('setting_key, setting_value');

    if (error) {
        console.error('Error fetching settings:', error);
        return null;
    }

    const config = {};
    settings.forEach(s => config[s.setting_key] = s.setting_value);

    // Update contact info in the DOM if elements exist
    updateElementText('[data-setting="school_address"]', config.school_address);
    updateElementText('[data-setting="school_phone"]', config.school_phone);
    updateElementText('[data-setting="school_email"]', config.school_email);
    updateElementText('[data-setting="operating_hours"]', config.operating_hours);
    updateElementText('[data-setting="school_tagline"]', config.school_tagline);

    return config;
}

function updateElementText(selector, text) {
    if (!text) return;
    const elements = document.querySelectorAll(selector);
    elements.forEach(el => {
        if (el.tagName === 'A' && selector.includes('email')) {
            el.href = `mailto:${text}`;
            el.textContent = text;
        } else if (el.tagName === 'A' && selector.includes('phone')) {
            el.href = `tel:${text}`;
            el.textContent = text;
        } else {
            el.textContent = text;
        }
    });
}
