FROM node:18

WORKDIR /app

COPY frontend/package*.json . 
RUN npm install

COPY frontend/ .

RUN npm run build

EXPOSE 3001
ENV PORT=3001

CMD ["npm", "start"]
