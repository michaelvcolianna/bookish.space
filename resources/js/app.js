import './bootstrap';
import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

/**
 * Focus and select a field.
 *
 * @param  HTMLElement field
 * @return void
 */
const focusAndSelect = (field) => {
  field.focus()
  field.select()
}

if(typeof Livewire !== 'undefined')
{

  /**
   * Focus on new project title when add form is shown.
   */
  Livewire.on('displayNewProjectForm', () => {
    setTimeout(() => {
      focusAndSelect(document.querySelector('#project-title'))
    }, 50)
  })

  /**
   * Focus on project title when edit form is shown.
   */
  Livewire.on('displayEditProjectForm', ({ id }) => {
    setTimeout(() => {
      focusAndSelect(document.querySelector(`#project-${id}-title`))
    }, 50)
  })

  /**
   * Focus on project tags when tag form is shown.
   */
  Livewire.on('displayTagProjectForm', ({ id }) => {
    setTimeout(() => {
      focusAndSelect(document.querySelector(`#project-${id}-tags`))
    }, 50)
  })

} // end if(Livewire)
