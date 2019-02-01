import React from 'react'
import {PropTypes as T, implementPropTypes} from '#/main/app/prop-types'

import {FormField as FormFieldTypes} from '#/main/core/layout/form/prop-types'

import {Select} from '#/main/app/input/components/select'
import {Checkboxes} from '#/main/app/input/components/checkboxes'
import {Radios} from '#/main/app/input/components/radios'

// todo : adds min and max values for multiple: true

/**
 * @param props
 * @constructor
 */
const ChoiceInput = props => {
  if (!props.condensed && props.multiple) {
    return (
      <Checkboxes {...props} />
    )
  }

  if (!props.condensed && !props.multiple) {
    return (
      <Radios {...props} />
    )
  }

  return (
    <Select {...props} />
  )
}

implementPropTypes(ChoiceInput, FormFieldTypes, {
  // more precise value type
  value: T.oneOfType([T.string, T.number, T.array]),
  // custom props
  choices: T.object.isRequired,
  disabledChoices: T.arrayOf(T.string),
  multiple: T.bool,
  condensed: T.bool
}, {
  multiple: false,
  condensed: false
})

export {
  ChoiceInput
}