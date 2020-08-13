const requireComponent = require.context(
    // The relative path of the components folder
    '@/components',
    // Whether or not to look in subfolders
    true,
    // The regular expression used to match base component filenames
    /[A-Z]\w+\.vue$/
);

export default {
    install(Vue) {
        requireComponent.keys().forEach(fileName => {
            let component = requireComponent(fileName);

            Vue.component(component.default.name, component.default);
        });
    },
};
