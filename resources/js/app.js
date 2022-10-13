import './bootstrap'

import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

/**
 * Focus and select a field.
 *
 * @param  HTMLElement  field
 * @return void
 */
const focusAndSelectField = (field) => {
  field.focus()
  field.select()
}

/**
 * Focus on new project title when add form is visible.
 */
Livewire.on('displayNewProjectForm', () => {
  setTimeout(() => {
    focusAndSelectField(document.querySelector('#project-title'))
  }, 50)
})

/**
 * Focus on a project title when editing form is visible.
 */
Livewire.on('editProject', id => {
  setTimeout(() => {
    focusAndSelectField(document.querySelector(`#project-${id}-title`))
  }, 50)
})
