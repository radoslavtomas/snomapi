import './bootstrap';

const confirmDeleteUser = () => {
    if(confirm('Are you sure?')) {
        const form = document.getElementById('delete_user');
        form.submit();
    }
}

window.confirmDeleteUser = confirmDeleteUser
