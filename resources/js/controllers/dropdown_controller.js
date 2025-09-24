import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["menu"]
    static classes = ["show", "hide"]

    connect() {
        console.log("Dropdown controller connected")
        // Close dropdown when clicking outside
        this.boundClickOutside = this.clickOutside.bind(this)
        document.addEventListener("click", this.boundClickOutside)
    }

    disconnect() {
        document.removeEventListener("click", this.boundClickOutside)
    }

    toggle(event) {
        event.stopPropagation()

        const menu = this.menuTarget
        const isHidden = menu.classList.contains("hidden")

        // Close all other dropdowns first
        document.querySelectorAll('[data-controller~="dropdown"]').forEach(element => {
            if (element !== this.element) {
                const otherController = this.application.getControllerForElementAndIdentifier(element, "dropdown")
                if (otherController) {
                    otherController.hide()
                }
            }
        })

        if (isHidden) {
            this.show()
        } else {
            this.hide()
        }
    }

    show() {
        const menu = this.menuTarget

        // Show menu
        menu.classList.remove("hidden")

        // Rotate chevron if present
        const chevron = this.element.querySelector('svg')
        if (chevron) {
            chevron.style.transform = 'rotate(180deg)'
        }

        // Animate in
        requestAnimationFrame(() => {
            menu.classList.remove("opacity-0", "scale-95")
            menu.classList.add("opacity-100", "scale-100")
        })
    }

    hide() {
        const menu = this.menuTarget

        // Reset chevron if present
        const chevron = this.element.querySelector('svg')
        if (chevron) {
            chevron.style.transform = 'rotate(0deg)'
        }

        // Animate out
        menu.classList.remove("opacity-100", "scale-100")
        menu.classList.add("opacity-0", "scale-95")

        // Hide after animation
        setTimeout(() => {
            menu.classList.add("hidden")
        }, 200)
    }

    clickOutside(event) {
        // Don't close if clicking inside the dropdown
        if (this.element.contains(event.target)) {
            return
        }

        this.hide()
    }

    // Prevent closing when clicking inside menu
    preventClose(event) {
        event.stopPropagation()
    }
}