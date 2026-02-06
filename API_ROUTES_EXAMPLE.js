/**
 * API Routes
 * 
 * Define all API endpoints here for your Vue frontend to consume
 * Example routes are provided below
 */

import express from 'express';
const router = express.Router();

// Example GET endpoint
router.get('/items', (req, res) => {
  res.json({
    success: true,
    data: [
      { id: 1, name: 'Item 1', description: 'First item' },
      { id: 2, name: 'Item 2', description: 'Second item' },
    ]
  });
});

// Example POST endpoint
router.post('/items', (req, res) => {
  const { name, description } = req.body;
  res.json({
    success: true,
    message: 'Item created successfully',
    data: { id: 3, name, description }
  });
});

export default router;
