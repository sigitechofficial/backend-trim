const express = require('express')
// utf8mb4_general_ci
const dotenv = require('dotenv')
dotenv.config({ path: '../.env' })

// const http = require('http');
const cors = require('cors')

const app = express()
const server = require('http').createServer(app)
const db = require('./models')
const errorHandler = require('./middlewares/errorHandler')
const { initializeWebSocket } = require('./socket_io')
// Importing routes
const salonAuth = require('./routes/salonRoutes/authRoute')
const salonRegistration = require('./routes/salonRoutes/salonRoute')
const employeeRoute = require('./routes/salonRoutes/employeeRoute')
const bookingRoute = require('./routes/salonRoutes/bookingRoute')
const customerRoute = require('./routes/userRoutes/customerRoute')
const customerAuth = require('./routes/userRoutes/authRoute')
const adminRoute = require('./routes/adminRoutes/adminRoute')
const reportsRoute = require('./routes/salonRoutes/reportsRoute')
const performanceRoute = require('./routes/salonRoutes/performanceRoute')
const payoutRoute = require('./routes/payoutRoutes/payoutRoute')
// Use the workerRoute for the /workerinfo route
app.use(cors())
app.use(express.json())

app.use('/salon/v1/auth', salonAuth)
app.use('/salon/v1', salonRegistration)
app.use('/salon/v1/employee', employeeRoute)
app.use('/salon/v1/bookings', bookingRoute)
// Customer
app.use('/customer-auth', customerAuth)
app.use('/customer', customerRoute)
app.use('/admin', adminRoute)
app.use('/reports', reportsRoute)
//performance-dashboard
app.use('/performance-dashboard', performanceRoute)
//Employee Payout
app.use('/employee-payout', payoutRoute)
initializeWebSocket(server)
// Route mounting
// app.use((req, res, next) => {
//   const error = new Error(`Route not found ~ ${req.url}`);
//   error.status = 404;
//   next(error);
// });

app.use(errorHandler)
// ... (other middleware and routes as needed)

const serverPort = process.env.PORT || 3000
const syncDb = 0
if (syncDb) db.sequelize.sync({ alter: true })

server.listen(serverPort, (err) => {
  if (err) throw err
  console.log(`Listening on port :${serverPort}`)
})

//utf8mb4_general_ci
