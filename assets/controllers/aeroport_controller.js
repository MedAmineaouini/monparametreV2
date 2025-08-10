// assets/controllers/aeroport_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['select', 'input', 'timeInput'];
    static values = {
        type: { type: String, default: '' }, // 'departure' or 'arrival'
        defaultTime: String
    };

    connect() {
        this.updateAeroport();
        this.setupEventListeners();
    }

    disconnect() {
        this.removeEventListeners();
    }

    setupEventListeners() {
        if (this.hasTimeInputTarget) {
            this.timeInputTarget.addEventListener('change', this.handleTimeChange.bind(this));
        }
    }

    removeEventListeners() {
        if (this.hasTimeInputTarget) {
            this.timeInputTarget.removeEventListener('change', this.handleTimeChange.bind(this));
        }
    }

    updateAeroport() {
        const selectedOption = this.selectTarget.options[this.selectTarget.selectedIndex];
        const aeroValue = selectedOption ? selectedOption.dataset.aero || '' : '';
        
        this.inputTarget.value = aeroValue;
        
        // Set default time if configured and no time is set
        if (this.defaultTimeValue && this.hasTimeInputTarget && !this.timeInputTarget.value) {
            this.timeInputTarget.value = this.defaultTimeValue;
        }

        // Additional logic based on airport type
        if (this.typeValue === 'departure') {
            this.handleDepartureChange(aeroValue);
        } else if (this.typeValue === 'arrival') {
            this.handleArrivalChange(aeroValue);
        }
    }

    handleTimeChange(event) {
        const timeValue = event.target.value;
        // You can add time validation or formatting here
        console.log(`${this.typeValue} time changed to:`, timeValue);
        
        // Dispatch a custom event if other parts of your app need to react
        this.dispatch('timeUpdated', { 
            detail: { 
                type: this.typeValue,
                time: timeValue,
                airport: this.inputTarget.value
            } 
        });
    }

    handleDepartureChange(airportCode) {
        // Special handling for departure airport changes
        console.log('Departure airport changed to:', airportCode);
        
        // Example: You could automatically set a default departure time
        // if (airportCode === 'CDG' && !this.timeInputTarget.value) {
        //     this.timeInputTarget.value = '06:00';
        // }
    }

    handleArrivalChange(airportCode) {
        // Special handling for arrival airport changes
        console.log('Arrival airport changed to:', airportCode);
        
        // Example: You could calculate flight duration based on departure/arrival
        // if (this.hasTimeInputTarget) {
        //     this.calculateFlightDuration();
        // }
    }

    calculateFlightDuration() {
        // This would need integration with your departure time controller
        console.log('Calculating flight duration...');
        // Implementation would depend on your app's specific requirements
    }
}