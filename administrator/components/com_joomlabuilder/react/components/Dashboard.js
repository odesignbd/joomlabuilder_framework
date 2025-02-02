 
class Dashboard extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            templates: []
        };
    }

    componentDidMount() {
        this.fetchTemplates();
    }

    fetchTemplates = async () => {
        try {
            const response = await fetch("index.php?option=com_joomlabuilder&task=templates.get");
            const data = await response.json();
            this.setState({ templates: data });
        } catch (error) {
            console.error("Error fetching templates:", error);
        }
    };

    render() {
        return (
            <div className="container">
                <h1>Dashboard</h1>
                <p>Manage your Joomla templates efficiently.</p>
                <ul className="list-group">
                    {this.state.templates.map(template => (
                        <li key={template.id} className="list-group-item">
                            {template.name} - <button className="btn btn-primary btn-sm" onClick={() => this.props.navigateTo('builder')}>Edit</button>
                        </li>
                    ))}
                </ul>
            </div>
        );
    }
}
