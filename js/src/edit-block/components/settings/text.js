// @ts-check

/**
 * External dependencies
 */
import React from 'react';

/**
 * Internal dependencies
 */
import { Input } from '../';

/**
 * @typedef {Object} FieldSettingsProps The component props.
 * @property {Object} setting This setting.
 * @property {string|undefined} value The setting value.
 */

/**
 * The field settings.
 *
 * @param {FieldSettingsProps} props The component props.
 * @return {React.ReactElement} The component for the admin page.
 */
const Text = ( props ) => {
	return <Input { ...props } type="text" />;
};

export default Text;
