/**
 * External dependencies
 */
import * as React from 'react';

/**
 * WordPress dependencies
 */
import { BaseControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import { InnerBlocks } from '@wordpress/block-editor';
import { EDIT_BLOCK_CONTEXT } from '../../common/constants';
import { Notice } from '../../common/components';

const GcbInnerBlocksControl = ( { field, context } ) => (
	<BaseControl
		label={ EDIT_BLOCK_CONTEXT === context ? undefined : field.label }
		help={ field.help }
		id={ `gcb-inner-blocks-${ field.name }` }
	>
		{
			EDIT_BLOCK_CONTEXT === context
				? (
					<>
						<BaseControl.VisualLabel>{ field.label }</BaseControl.VisualLabel>
						<Notice>
							<span className="text-sm">
								{ __( 'This field only works in the block editor.', 'genesis-custom-blocks' ) }
							</span>
						</Notice>
					</>
				) : <InnerBlocks />
		}
	</BaseControl>
);

export default GcbInnerBlocksControl;
