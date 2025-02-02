class Builder extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            sections: []
        };
    }

    componentDidMount() {
        this.fetchSections();
    }

    fetchSections = async () => {
        try {
            const response = await fetch("index.php?option=com_joomlabuilder&task=builder.getSections");
            const data = await response.json();
            this.setState({ sections: data });
        } catch (error) {
            console.error("Error fetching sections:", error);
        }
    };

    addSection = () => {
        const newSection = { id: Date.now(), name: "New Section" };
        this.setState({ sections: [...this.state.sections, newSection] });
    };

    removeSection = (id) => {
        this.setState({ sections: this.state.sections.filter(section => section.id !== id) });
    };

    render() {
        return (
            <div className="container">
                <h1>Template Builder</h1>
                <p>Drag and drop sections to customize your template.</p>
                <button className="btn btn-success" onClick={this.addSection}>Add Section</button>
                <ul className="list-group mt-3">
                    {this.state.sections.map(section => (
                        <li key={section.id} className="list-group-item d-flex justify-content-between">
                            {section.name}
                            <button className="btn btn-danger btn-sm" onClick={() => this.removeSection(section.id)}>Remove</button>
                        </li>
                    ))}
                </ul>
            </div>
        );
    }
}
 
