import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './ServiceRequests.css';

function ServiceRequests() {
    const [requests, setRequests] = useState([]);
    const [formData, setFormData] = useState({
        aircraft_id: '',
        issue_description: '',
        priority: '',
        due_date: '',
        maintenance_company_id: ''
    });
    const [aircrafts, setAircrafts] = useState([]);
    const [companies, setCompanies] = useState([]);

    useEffect(() => {
        fetchRequests();
        fetchAircrafts();
        fetchCompanies();
    }, []);

    const fetchRequests = async () => {
        const response = await axios.get('http://localhost:8080/api/service_requests');
        setRequests(response.data);
    };

    const fetchAircrafts = async () => {
        const response = await axios.get('http://localhost:8080/api/aircrafts');
        setAircrafts(response.data);
    };

    const fetchCompanies = async () => {
        const response = await axios.get('http://localhost:8080/api/maintenance_companies');
        setCompanies(response.data);
    };

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        await axios.post('http://localhost:8080/api/service_requests', formData);
        setFormData({ aircraft_id: '', issue_description: '', priority: '', due_date: '', maintenance_company_id: '' });
        fetchRequests();
    };

    const handleDelete = async (id) => {
        await axios.delete(`http://localhost:8080/api/service_requests/${id}`);
        fetchRequests();
    };

    const handleStatusUpdate = async (id, newStatus) => {
        await axios.patch(`http://localhost:8080/api/service_requests/${id}/status`, { status: newStatus });
        fetchRequests();
    };

    return (
        <div className="service-requests-container">
            <h2>Service Request Management</h2>
            <form onSubmit={handleSubmit} className="input-group">
                <select name="aircraft_id" value={formData.aircraft_id} onChange={handleChange} required>
                    <option value="">Select Aircraft</option>
                    {aircrafts.map(aircraft => (
                        <option key={aircraft.id} value={aircraft.id}>{aircraft.model}</option>
                    ))}
                </select>
                <select name="maintenance_company_id" value={formData.maintenance_company_id} onChange={handleChange} required>
                    <option value="">Select Company</option>
                    {companies.map(company => (
                        <option key={company.id} value={company.id}>{company.name}</option>
                    ))}
                </select>
                <input type="text" name="issue_description" value={formData.issue_description} onChange={handleChange} placeholder="Issue Description" required />
                <select name="priority" value={formData.priority} onChange={handleChange} required>
                    <option value="">Select Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
                <input type="date" name="due_date" value={formData.due_date} onChange={handleChange} required />
                <button type="submit">Create</button>
            </form>
            <ul className="service-requests-list">
                {requests.map(request => (
                    <li key={request.id} className="service-request-item">
                        <span>{request.issue_description} - {request.priority} - {request.due_date}</span>
                        <div className="button-group">
                            <button className="status-button" onClick={() => handleStatusUpdate(request.id, 'in_progress')}>Mark In Progress</button>
                            <button className="status-button" onClick={() => handleStatusUpdate(request.id, 'completed')}>Mark Completed</button>
                            <button className="delete-button" onClick={() => handleDelete(request.id)}>Delete</button>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default ServiceRequests;
