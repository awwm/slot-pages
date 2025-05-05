import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl } from '@wordpress/components';
import apiFetch from '@wordpress/api-fetch';
import { useEffect, useState } from '@wordpress/element';

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
        const [slots, setSlots] = useState([]);

        useEffect(() => {
            apiFetch({ path: '/slot-pages/v1/slots' }).then((data) => {
                let sorted = [...data];
                if (sorting === 'random') {
                    sorted.sort(() => 0.5 - Math.random());
                }
                setSlots(sorted.slice(0, limit));
            });
        }, [limit, sorting]);

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
                <div className="slots-grid-preview" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(120px, 1fr))', gap: '10px' }}>
                    {slots.map((slot) => (
                        <div key={slot.id} style={{ border: '1px solid #ddd', padding: '10px', textAlign: 'center' }}>
                            {slot.image && <img src={slot.image} alt={slot.title} style={{ maxWidth: '100%' }} />}
                            <strong>{slot.title}</strong>
                            <div>{slot.provider}</div>
                        </div>
                    ))}
                </div>
            </>
        );
    },
    save() {
        return null; // Rendered in PHP
    },
});
