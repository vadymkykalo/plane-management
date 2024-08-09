import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './MaintenanceCompanies.css';

function MaintenanceCompanies() {
    const [companies, setCompanies] = useState([]);
    const [formData, setFormData] = useState({ name: '', contact: '', specialization: '' });
    const [editing, setEditing] = useState(false);
    const [editingId, setEditingId] = useState(null);
    const [maintenanceHistory, setMaintenanceHistory] = useState([]);
    const [selectedCompanyId, setSelectedCompanyId] = useState(null);

    useEffect(() => {
        fetchCompanies();
    }, []);

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
        if (editing) {
            await axios.put(`http://localhost:8080/api/maintenance_companies/${editingId}`, formData);
        } else {
            await axios.post('http://localhost:8080/api/maintenance_companies', formData);
        }
        setFormData({ name: '', contact: '', specialization: '' });
        setEditing(false);
        setEditingId(null);
        fetchCompanies();
    };

    const handleEdit = (company) => {
        setFormData(company);
        setEditing(true);
        setEditingId(company.id);
    };

    const handleDelete = async (id) => {
        await axios.delete(`http://localhost:8080/api/maintenance_companies/${id}`);
        fetchCompanies();
    };

    const fetchMaintenanceHistory = async (companyId) => {
        try {
            if (selectedCompanyId === companyId) {
                // Если та же компания выбрана повторно, скрываем историю
                setSelectedCompanyId(null);
                setMaintenanceHistory([]);
            } else {
                const response = await axios.get(`http://localhost:8080/api/maintenance_companies/${companyId}/maintenance_history`);
                setMaintenanceHistory(response.data);
                setSelectedCompanyId(companyId);
            }
        } catch (error) {
            console.error('Error fetching maintenance history:', error);
        }
    };

    return (
        <div className="maintenance-companies-container">
            <h2>Maintenance Company Management</h2>
            <form onSubmit={handleSubmit} className="input-group">
                <input type="text" name="name" value={formData.name} onChange={handleChange} placeholder="Name" required />
                <input type="text" name="contact" value={formData.contact} onChange={handleChange} placeholder="Contact" required />
                <input type="text" name="specialization" value={formData.specialization} onChange={handleChange} placeholder="Specialization" required />
                <button type="submit">{editing ? 'Update' : 'Create'}</button>
            </form>
            <ul className="maintenance-companies-list">
                {companies.map(company => (
                    <li key={company.id} className="maintenance-company-item">
                        <span>{company.name} - {company.contact} - {company.specialization}</span>
                        <div className="button-group">
                            <button className="history-button" onClick={() => fetchMaintenanceHistory(company.id)}>View Aircraft History</button>
                            <button className="edit-button" onClick={() => handleEdit(company)}>Edit</button>
                            <button className="delete-button" onClick={() => handleDelete(company.id)}>Delete</button>
                        </div>
                        {selectedCompanyId === company.id && (
                            <div className="maintenance-history">
                                <h3>Aircraft History</h3>
                                {maintenanceHistory.length > 0 ? (
                                    <ul>
                                        {maintenanceHistory.map(historyItem => (
                                            <li key={historyItem.id}>
                                                <strong>{historyItem.aircraft.model} - {historyItem.aircraft.serial_number}</strong><br />
                                                {historyItem.service_request && (
                                                    <>
                                                        <strong>Issue:</strong> {historyItem.service_request.issue_description}<br />
                                                        <strong>Status:</strong> {historyItem.service_request.status}<br />
                                                        <strong>Date:</strong> {new Date(historyItem.service_request.due_date).toLocaleDateString()}
                                                    </>
                                                )}

                                            </li>
                                        ))}
                                    </ul>
                                ) : (
                                    <p>No aircrafts maintenance history available for this company.</p>
                                )}
                            </div>
                        )}
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default MaintenanceCompanies;
