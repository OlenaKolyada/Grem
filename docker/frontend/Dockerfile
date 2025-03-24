FROM node:18

WORKDIR /app

COPY frontend/package*.json . 
RUN npm install

COPY frontend/ .

ENV NODE_ENV=docker
ENV NEXT_PUBLIC_ENVIRONMENT=docker
ENV NEXT_PUBLIC_API_URL=http://localhost:8001

RUN npm run build

EXPOSE 3001
ENV PORT=3001

CMD ["npm", "start"]
