# docker/frontend/Dockerfile

FROM node:18

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

ENV NODE_ENV=docker

RUN npm run build

EXPOSE 3001

ENV PORT=3001

CMD ["npm", "start"]