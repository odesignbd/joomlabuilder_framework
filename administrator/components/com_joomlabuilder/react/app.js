class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            currentPage: 'dashboard'
        };
    }

    navigateTo = (page) => {
        this.setState({ currentPage: page });
    };

    renderPage = () => {
        switch (this.state.currentPage) {
            case 'dashboard':
                return <Dashboard navigateTo={this.navigateTo} />;
            case 'builder':
                return <Builder navigateTo={this.navigateTo} />;
            default:
                return <Dashboard navigateTo={this.navigateTo} />;
        }
    };

    render() {
        return (
            <div>
                <Navbar navigateTo={this.navigateTo} />
                <div className="container mt-4">
                    {this.renderPage()}
                </div>
            </div>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('joomlabuilder-admin'));
 
