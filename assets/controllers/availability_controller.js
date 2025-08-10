import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['display', 'ouvert', 'reserve', 'vendu'];
    
    connect() {
        console.log("Availability controller connected");
        this.calculate();
        this.setupEventListeners();
    }

    disconnect() {
        this.removeEventListeners();
    }

    setupEventListeners() {
        this.ouvertTarget.addEventListener('input', this.calculate.bind(this));
        this.reserveTarget.addEventListener('input', this.calculate.bind(this));
        this.venduTarget.addEventListener('input', this.calculate.bind(this));
    }

    removeEventListeners() {
        this.ouvertTarget.removeEventListener('input', this.calculate.bind(this));
        this.reserveTarget.removeEventListener('input', this.calculate.bind(this));
        this.venduTarget.removeEventListener('input', this.calculate.bind(this));
    }
    
    calculate() {
        try {
            const ouvert = this.safeParse(this.ouvertTarget.value);
            const reserve = this.safeParse(this.reserveTarget.value);
            const vendu = this.safeParse(this.venduTarget.value);
            
            const dispo = ouvert - reserve - vendu;
            this.displayTarget.value = dispo > 0 ? dispo : 0;
            
            console.log(`Availability calculated: ${dispo}`);
        } catch (error) {
            console.error("Availability calculation error:", error);
        }
    }

    safeParse(value) {
        const num = parseInt(value, 10);
        return isNaN(num) ? 0 : num;
    }
}