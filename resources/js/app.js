import './bootstrap'

import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

/**
 * Focus on new project title when form is shown
 */
Livewire.on('displayNewProjectForm', () => {
  setTimeout(() => {
    let projectTitle = document.querySelector('#project-title')

    // Focus & select, since closing doesn't clear prior data
    projectTitle.focus()
    projectTitle.select()
  }, 50)
})
