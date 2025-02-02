'use strict';

// Dashboard Component
function Dashboard() {
    return (
        React.createElement('section', { className: 'joomlabuilder-dashboard' },
            React.createElement('h2', null, 'Dashboard'),
            React.createElement('p', null, 'Welcome to the JoomlaBuilder Dashboard. Here you can manage your templates and settings.')
        )
    );
}

export default Dashboard;
