// delete-handler.js
class DeleteHandler {
    static init() {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', this.handleDelete.bind(this));
        });
    }

    static async handleDelete(e) {
        e.preventDefault();
        const form = e.target.closest('form');

        try {
            const result = await Swal.fire({
                title: 'Confirmer la suppression',
                text: 'Êtes-vous sûr de vouloir supprimer cet élément ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#ff3e1d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            });

            if (result.isConfirmed) {
                const response = await this.submitForm(form);
                await this.handleResponse(response);
            }
        } catch (error) {
            console.error('Delete error:', error);
            await Swal.fire('Erreur', error.message, 'error');
        }
    }

    static async submitForm(form) {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            throw new Error('Le serveur a retourné une réponse non-JSON');
        }

        return response.json();
    }

    static async handleResponse(data) {
        if (data.success) {
            await Swal.fire({
                title: 'Succès !',
                text: data.message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
            window.location.reload();
        } else {
            await Swal.fire({
                title: 'Erreur',
                html: this.formatErrorHtml(data),
                icon: 'error',
                confirmButtonText: 'Compris'
            });
        }
    }

    static formatErrorHtml(data) {
        return `
      <div class="text-danger">
        <i class="bx bx-error-alt fs-1"></i>
        <p class="mt-3">${data.message}</p>
        ${data.reference ? `<small class="text-muted d-block mt-2">Référence : ${data.reference}</small>` : ''}
      </div>
    `;
    }
}

// Initialisation quand le DOM est prêt
document.addEventListener('DOMContentLoaded', () => DeleteHandler.init());