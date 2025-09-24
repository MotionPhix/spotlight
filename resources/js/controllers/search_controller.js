import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["form", "searchInput", "statusSelect", "clearButton"]

    connect() {
        console.log("Search controller connected")
        this.updateClearButton()
    }

    // Auto-submit form when status changes
    statusChanged() {
        this.submitForm()
    }

    // Submit form with current values
    submitForm() {
        this.formTarget.submit()
    }

    // Clear all filters
    clear() {
        this.searchInputTarget.value = ""
        this.statusSelectTarget.value = ""

        // Submit the cleared form
        this.submitForm()
    }

    // Update clear button visibility based on whether filters are active
    updateClearButton() {
        const hasSearch = this.searchInputTarget.value.length > 0
        const hasStatus = this.statusSelectTarget.value.length > 0

        if (hasSearch || hasStatus) {
            this.clearButtonTarget.classList.remove("hidden")
        } else {
            this.clearButtonTarget.classList.add("hidden")
        }
    }

    // Update clear button when search input changes
    searchInputChanged() {
        this.updateClearButton()
    }
}