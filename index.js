(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var __ = wp.i18n.__;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var TextControl = wp.components.TextControl;
    var MediaUpload = wp.blockEditor.MediaUpload;
    var Button = wp.components.Button;

    registerBlockType('devpress/newsletter-block', {
        attributes: {
            placeholder: {
                type: 'string',
                default: 'Email',
            },
            buttonImage: {
                type: 'string',
                default: null,
            },
			buttonBackgroundColor: {
                type: 'string',
                default: '#66D669',
            },
        },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var blockProps = useBlockProps();

            function updatePlaceholder(value) {
                setAttributes({ placeholder: value });
            }

            function updateButtonImage(media) {
                setAttributes({ buttonImage: media.url });
            }

            return el(
                wp.element.Fragment,
                null,
                el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: __('Settings', 'newsletter-block'), initialOpen: true },
                        el(TextControl, {
                            label: __('Placeholder', 'newsletter-block'),
                            value: attributes.placeholder,
                            onChange: updatePlaceholder,
                            help: __('Text displayed in the email input field.', 'newsletter-block'),
                        }),
						el(wp.components.ColorPalette, {
							value: attributes.buttonBackgroundColor,
							onChange: (newColor) => setAttributes({ buttonBackgroundColor: newColor }),
							label: __('Button Background Color', 'newsletter-block')
						}),
                        el(
                            MediaUpload,
                            {
								onSelect: updateButtonImage,
                                allowedTypes: ['image'],
                                render: function (obj) {
                                    return el(
                                        'div', {
											style: { display: 'flex', gap: '12px' }
										},
                                        el(
                                            Button,
                                            {
												label: __('Button Image', 'newsletter-block'),
												onClick: obj.open,
												isSecondary: true
											},
                                            attributes.buttonImage
                                                ? __('Change Button Image', 'newsletter-block')
                                                : __('Upload Button Image', 'newsletter-block')
                                        ),
                                        attributes.buttonImage &&
                                            el('img', {
                                                src: attributes.buttonImage,
                                                alt: __('Button Image Preview', 'newsletter-block'),
                                                style: { width: '34px', backgroundColor: '#EDEDED' },
                                            })
                                    );
                                },
                            }
                        )
                    )
                ),
                el(
                    'form',
                    { ...blockProps, onSubmit: (event) => event.preventDefault() },
                    el('input', {
                        type: 'email',
                        placeholder: attributes.placeholder,
                        required: true
                    }),
                    el(
                        'button',
                        {
                            type: 'submit',
                            style: { backgroundColor: attributes.buttonBackgroundColor, cursor: 'pointer' },
                        },
                        attributes.buttonImage
                            ? el('img', {
                                  src: attributes.buttonImage,
                                  alt: __('Submit', 'newsletter-block'),
                                  style: { height: '24px' },
                              })
                            : __('Submit', 'newsletter-block')
                    )
                )
            );
        },
        save: function (props) {
            var attributes = props.attributes;
            var blockProps = useBlockProps.save();

            return el(
                'form',
                { ...blockProps, action: '#', method: 'post' },
                el('input', {
                    type: 'email',
                    placeholder: attributes.placeholder,
                    required: true
                }),
                el(
                    'button',
                    {
                        type: 'submit',
                        style: { backgroundColor: attributes.buttonBackgroundColor, cursor: 'pointer' },
                    },
                    attributes.buttonImage
                        ? el('img', {
                              src: attributes.buttonImage,
                              alt: __('Submit', 'newsletter-block'),
                              style: { height: '24px' },
                          })
                        : 'Submit'
                )
            );
        },
    });
})(window.wp);
