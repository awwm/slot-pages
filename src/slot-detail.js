import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import { useEffect, useState } from '@wordpress/element';

registerBlockType('slot-pages/slot-detail', {
    title: __('Slot Detail', 'slot-pages'),
    icon: 'info-outline',
    category: 'widgets',
    edit() {
        const [slot, setSlot] = useState(null);

        useEffect(() => {
            apiFetch({ path: '/slot-pages/v1/latest-slot' }).then((data) => {
                setSlot(data);
            });
        }, []);

        if (!slot) {
            return <p>{__('Loading latest slot...', 'slot-pages')}</p>;
        }

        return (
            <div className="slot-detail-preview" style={{ border: '1px solid #ddd', padding: '10px' }}>
                {slot.image && <img src={slot.image} alt={slot.title} style={{ maxWidth: '100%', marginBottom: '10px' }} />}
                <h3>{slot.title}</h3>
                <p><strong>{__('Provider:', 'slot-pages')}</strong> {slot.provider}</p>
                <div dangerouslySetInnerHTML={{ __html: slot.content }} />
            </div>
        );
    },
    save() {
        return null; // Rendered in PHP
    },
});
