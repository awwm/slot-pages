import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl } from '@wordpress/components';

registerBlockType('slot-pages/slots-grid', {
    title: __('Slots Grid', 'slot-pages'),
    icon: 'grid-view',
    category: 'widgets',
    attributes: {
        limit: { type: 'number', default: 6 },
        sorting: { type: 'string', default: 'recent' },
    },
    edit({ attributes, setAttributes }) {
        const { limit, sorting } = attributes;

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Grid Settings', 'slot-pages')}>
                        <RangeControl
                            label={__('Number of Slots', 'slot-pages')}
                            value={limit}
                            onChange={(value) => setAttributes({ limit: value })}
                            min={1}
                            max={20}
                        />
                        <SelectControl
                            label={__('Sorting Mode', 'slot-pages')}
                            value={sorting}
                            options={[
                                { label: __('Recent', 'slot-pages'), value: 'recent' },
                                { label: __('Random', 'slot-pages'), value: 'random' },
                            ]}
                            onChange={(value) => setAttributes({ sorting: value })}
                        />
                    </PanelBody>
                </InspectorControls>
                <p>{__('Slots Grid Block (preview in frontend)', 'slot-pages')}</p>
            </>
        );
    },
    save() {
        return null; // Rendered in PHP
    },
});
