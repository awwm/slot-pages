import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
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
        columns: { type: 'number', default: 3 },
        titleColor: { type: 'string', default: '#000000' },
        starColor: { type: 'string', default: '#FFD700' },
        providerColor: { type: 'string', default: '#555555' },
        wagerColor: { type: 'string', default: '#555555' },
        buttonBgColor: { type: 'string', default: '#0073aa' },
        buttonTextColor: { type: 'string', default: '#ffffff' },
        titleFontSize: { type: 'number', default: 16 },
        providerFontSize: { type: 'number', default: 14 },
        wagerFontSize: { type: 'number', default: 14 },
    },
    edit({ attributes, setAttributes }) {
        const {
            limit, sorting, columns,
            titleColor, starColor, providerColor, wagerColor, buttonBgColor, buttonTextColor,
            titleFontSize, providerFontSize, wagerFontSize,
        } = attributes;

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
                        <RangeControl
                            label={__('Columns (per row)', 'slot-pages')}
                            value={columns}
                            onChange={(value) => setAttributes({ columns: value })}
                            min={1}
                            max={6}
                        />
                        <RangeControl
                            label={__('Title Font Size (px)', 'slot-pages')}
                            value={titleFontSize}
                            onChange={(value) => setAttributes({ titleFontSize: value })}
                            min={10}
                            max={40}
                        />
                        <RangeControl
                            label={__('Provider Font Size (px)', 'slot-pages')}
                            value={providerFontSize}
                            onChange={(value) => setAttributes({ providerFontSize: value })}
                            min={10}
                            max={30}
                        />
                        <RangeControl
                            label={__('Wager Font Size (px)', 'slot-pages')}
                            value={wagerFontSize}
                            onChange={(value) => setAttributes({ wagerFontSize: value })}
                            min={10}
                            max={30}
                        />
                    </PanelBody>

                    <PanelColorSettings
                        title={__('Color Settings', 'slot-pages')}
                        colorSettings={[
                            {
                                value: titleColor,
                                onChange: (value) => setAttributes({ titleColor: value }),
                                label: __('Title Color', 'slot-pages'),
                            },
                            {
                                value: starColor,
                                onChange: (value) => setAttributes({ starColor: value }),
                                label: __('Star Color', 'slot-pages'),
                            },
                            {
                                value: providerColor,
                                onChange: (value) => setAttributes({ providerColor: value }),
                                label: __('Provider Color', 'slot-pages'),
                            },
                            {
                                value: wagerColor,
                                onChange: (value) => setAttributes({ wagerColor: value }),
                                label: __('Wager Color', 'slot-pages'),
                            },
                            {
                                value: buttonBgColor,
                                onChange: (value) => setAttributes({ buttonBgColor: value }),
                                label: __('Button Background Color', 'slot-pages'),
                            },
                            {
                                value: buttonTextColor,
                                onChange: (value) => setAttributes({ buttonTextColor: value }),
                                label: __('Button Text Color', 'slot-pages'),
                            },
                        ]}
                    />
                </InspectorControls>

                <div
                    className="slots-grid-preview"
                    style={{
                        display: 'grid',
                        gridTemplateColumns: `repeat(${columns}, 1fr)`,
                        gap: '10px',
                    }}
                >
                    {slots.map((slot) => (
                        <div
                            key={slot.id}
                            style={{
                                border: '1px solid #ddd',
                                padding: '10px',
                                textAlign: 'center',
                                fontSize: `${titleFontSize}px`,
                            }}
                        >
                            {slot.image && (
                                <img src={slot.image} alt={slot.title} style={{ maxWidth: '100%' }} />
                            )}
                            <strong style={{ color: titleColor, display: 'block', margin: '5px 0' }}>
                                {slot.title}
                            </strong>
                            <div style={{ color: starColor, margin: '3px 0' }}>
                                {'★'.repeat(slot.star_rating)}{'☆'.repeat(5 - slot.star_rating)}
                            </div>
                            <div
                                style={{
                                    color: providerColor,
                                    fontSize: `${providerFontSize}px`,
                                    margin: '3px 0',
                                }}
                            >
                                {slot.provider}
                            </div>
                            <div
                                style={{
                                    color: wagerColor,
                                    fontSize: `${wagerFontSize}px`,
                                    margin: '3px 0',
                                }}
                            >
                                Wager: {slot.min_wager} - {slot.max_wager}
                            </div>
                            <a
                                href={slot.link}
                                style={{
                                    display: 'inline-block',
                                    marginTop: '5px',
                                    padding: '5px 10px',
                                    backgroundColor: buttonBgColor,
                                    color: buttonTextColor,
                                    textDecoration: 'none',
                                    borderRadius: '4px',
                                }}
                            >
                                More Info
                            </a>
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
