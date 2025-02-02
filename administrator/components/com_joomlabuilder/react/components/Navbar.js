'use strict';

// Navbar Component
function Navbar() {
    return (
        React.createElement('nav', { className: 'joomlabuilder-navbar' },
            React.createElement('ul', { className: 'nav-links' },
                React.createElement('li', null, React.createElement('a', { href: '#' }, 'Home')),
                React.createElement('li', null, React.createElement('a', { href: '#' }, 'Dashboard')),
                React.createElement('li', null, React.createElement('a', { href: '#' }, 'Builder'))
            )
        )
    );
}

export default Navbar;