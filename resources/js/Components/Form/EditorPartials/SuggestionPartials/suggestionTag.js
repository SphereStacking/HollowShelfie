import {VueRenderer} from '@tiptap/vue-3'
import tippy from 'tippy.js'
import { PluginKey } from '@tiptap/pm/state'
import SuggestionTagRenderer from './SuggestionTagRenderer.vue'

export default {
  pluginKey: new PluginKey('suggestionTag'),
  char: '#',

  items: ({ query }) => {
    return query
  },

  render: () => {
    let component
    let popup

    return {
      onStart: props => {
        component = new VueRenderer(SuggestionTagRenderer, {
          // using vue 2:
          // parent: this,
          // propsData: props,
          // using vue 3:
          props,
          editor: props.editor,
        })

        if (!props.clientRect) {
          return
        }

        popup = tippy('body', {
          getReferenceClientRect: props.clientRect,
          appendTo: () => document.body,
          content: component.element,
          showOnCreate: true,
          interactive: true,
          trigger: 'manual',
          placement: 'bottom-start',
        })
      },

      onUpdate(props) {
        component.updateProps(props)

        if (!props.clientRect) {
          return
        }

        popup[0].setProps({
          getReferenceClientRect: props.clientRect,
        })
      },

      onKeyDown(props) {
        if (props.event.key === 'Escape') {
          popup[0].hide()

          return true
        }

        return component.ref?.onKeyDown(props)
      },

      onExit() {
        popup[0].destroy()
        component.destroy()
      },
    }
  },
}
