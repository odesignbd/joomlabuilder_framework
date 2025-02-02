'use strict';

// Import necessary components
import Navbar from './components/Navbar.js';
import Dashboard from './components/Dashboard.js';
import Builder from './components/Builder.js';

// Ensure DOM is ready before React loads
window.addEventListener('DOMContentLoaded', () => {
    const rootElement = document.getElementById('joomlabuilder-react-root');
    if (!rootElement) {
        console.error('React root element not found. Ensure index.html contains a div with id="joomlabuilder-react-root".');
        return;
    }

    ReactDOM.render(
        React.createElement(App, null),
        rootElement
    );
});

// Main App Component
function App() {
    return (
        React.createElement('div', { className: 'joomlabuilder-container' },
            React.createElement(Navbar, null),
            React.createElement('main', { className: 'main-content' },
                React.createElement(Dashboard, null),
                React.createElement(Builder, null)
            )
        )
    );
}
